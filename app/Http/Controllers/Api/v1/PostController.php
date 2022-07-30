<?php

namespace App\Http\Controllers\Api\v1;

use App\Http\Controllers\Controller;
use App\Http\Requests\PostRequest;
use App\Http\Resources\PostResource;
use App\Models\Post;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class PostController extends Controller
{

    /**
     * @OA\Get(
     *      path="/posts",
     *      operationId="getPostList",
     *      tags={"블로그 포스트"},
     *      summary="모든 포스팅 가져오기",
     *      description="모든 포스팅을 가져온다.",
     *      security={{"bearer_token":{}}},
     *      @OA\Parameter(
     *         description="파라매터",
     *         in="query",
     *         name="page",
     *         required=false,
     *         @OA\Schema(type="int"),
     *         @OA\Examples(example="int", value="1", summary="페이지"),
     *      ),
     *      @OA\Response(
     *          response=200,
     *          description="응답 성공"
     *       ),
     *       @OA\Response(response=400, description="Bad request"),
     *       security={
     *           {"api_key_security_example": {}}
     *       }
     *     )
     *
     * Returns list of projects
     */
    public function index()
    {
        return PostResource::collection(
            Post::where('is_published', false)->orderBy('updated_at', 'desc')->paginate(10)
        );
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }




    /**
     * @OA\Post(
     *      path="/posts",
     *      operationId="storePost",
     *      tags={"블로그 포스트"},
     *      summary="포스트 추가하기",
     *      description="포스팅을 추가하고 추가된 포스팅을 반환한다.",
     *     @OA\RequestBody(
     *          required=true,
     *          @OA\JsonContent(ref="#/components/schemas/PostRequest")
     *      ),
     *
     *      @OA\Response(
     *          response=201,
     *          description="응답 성공 새 포스팅 만들어짐",
     *          @OA\JsonContent(ref="#/components/schemas/Post")
     *       ),
     *       @OA\Response(response=400, description="Bad request"),
     *       security={
     *           {"api_key_security_example": {}}
     *       }
     *     )
     *
     * Returns list of projects
     */
    public function store(PostRequest $request)
    {
        $data = json_decode($request->getContent(), true); // 리퀘스트 바디 부분

        $title = $data['title'];
        $content = $data['content'];
        $is_published = $data['is_published'];

        $newPost = Post::create([
            'title' => $title,
            'content' => $content,
            'is_published' => $is_published,
        ]);

        $createdPost = new PostResource($newPost);

        return  response()->json([
            'data' => $createdPost,
            "message" => "포스트 등록이 완료되었습니다"
        ], Response::HTTP_CREATED);

    }

    /**
     * @OA\Get(
     *      path="/posts/{id}",
     *      operationId="getPostById",
     *      tags={"블로그 포스트"},
     *      summary="특정 포스팅 가져오기",
     *      description="특정 포스팅 아이템을 가져온다.",
     *     @OA\Parameter(
     *          name="id",
     *          description="Post_id",
     *          required=true,
     *          in="path",
     *          @OA\Schema(
     *              type="integer"
     *          )
     *      ),
     *
     *      @OA\Response(
     *          response=200,
     *          description="응답 성공",
     *          @OA\JsonContent(ref="#/components/schemas/Post")
     *       ),
 *          @OA\Response(
     *          response=404,
     *          description="데이터를 찾을 수 없습니다"
     *       ),
     *       @OA\Response(response=400, description="Bad request"),
     *       security={
     *           {"api_key_security_example": {}}
     *       }
     *     )
     *
     * Returns list of projects
     */
    public function show($id)
    {
        if (Post::where('id', $id)->exists()){
            $foundPost = Post::find($id);
            if (!$foundPost->is_published) {
                return response()->json([
                   "message" => "해당 포스팅을 찾을 수 없습니다."
                ], Response::HTTP_NOT_FOUND);
            }
            return new PostResource($foundPost);
        } else {
            return response()->json([
                "message" => "해당 포스팅을 찾을 수 없습니다."
            ], Response::HTTP_NOT_FOUND);
        }
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * @OA\Put(
     *      path="/posts/{id}",
     *      operationId="updatePost",
     *      tags={"블로그 포스트"},
     *      summary="기존 포스팅 수정하기",
     *      description="기존 포스팅을 수정하고 수정된 포스팅을 반환한다.",
     *
     *      @OA\Parameter(
     *          name="id",
     *          description="Post_id",
     *          required=true,
     *          in="path",
     *          @OA\Schema(
     *              type="integer"
     *          )
     *      ),
     *
     *     @OA\RequestBody(
     *          required=true,
     *          @OA\JsonContent(ref="#/components/schemas/PostRequest")
     *      ),
     *
     *      @OA\Response(
     *          response=200,
     *          description="응답 성공",
     *          @OA\JsonContent(ref="#/components/schemas/Post")
     *       ),
     *       @OA\Response(response=400, description="Bad request"),
     *       security={
     *           {"api_key_security_example": {}}
     *       }
     *     )
     *
     * Returns list of projects
     */
    public function update(PostRequest $request, $id)
    {
        if (Post::where('id', $id)->exists()){

            $foundPost = Post::find($id);

            $foundPost->update($request->all());

            return response()->json([
                "data" =>  new PostResource($foundPost),
                "message" => "포스팅을 성공적으로 수정했습니다"
            ], Response::HTTP_OK);

        } else {
            return response()->json([
                "message" => "해당 포스팅을 찾을 수 없습니다."
            ], Response::HTTP_NOT_FOUND);
        }
    }


    /**
     * @OA\Delete(
     *      path="/posts/{id}",
     *      operationId="deletePost",
     *      tags={"블로그 포스트"},
     *      summary="기존 포스팅 삭제하기",
     *      description="기존 포스팅을 삭제한다.",
     *
     *      @OA\Parameter(
     *          name="id",
     *          description="Post_id",
     *          required=true,
     *          in="path",
     *          @OA\Schema(
     *              type="integer"
     *          )
     *      ),
     *
     *      @OA\Response(
     *          response=200,
     *          description="삭제 성공",
     *          @OA\JsonContent(ref="#/components/schemas/Post")
     *       ),
     *       @OA\Response(response=400, description="Bad request"),
     *       security={
     *           {"api_key_security_example": {}}
     *       }
     *     )
     *
     * Returns list of projects
     */
    public function destroy($id)
    {
        if (Post::where('id', $id)->exists()){
            $foundPost = Post::find($id);

            $deletedPost = new PostResource($foundPost);

            $foundPost->delete();

            return response()->json([
                "data" => $deletedPost,
                "message" => "포스팅을 성공적으로 삭제했습니다"
            ], Response::HTTP_OK);

        } else {
            return response()->json([
                "message" => "해당 포스팅을 찾을 수 없습니다."
            ], Response::HTTP_NOT_FOUND);
        }
    }
}
